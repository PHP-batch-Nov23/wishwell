import axios from 'axios';
import { Injectable } from '@angular/core';
import { AuthService } from './auth.service';

@Injectable({
  providedIn: 'root'
})
export class ServiceBackend {
  baseUrl = 'http://127.0.0.1:8000/api/';

  constructor(private authService: AuthService) {}

  get(url: string) {
    return axios.get(this.baseUrl + url);
  }

  registerPost(data: any) {
    return axios.post(this.baseUrl + 'register', data);
  }

  loginPost(data: any) {
    return axios.post(this.baseUrl + 'login', data);
  }

  getUserData() {
    return axios.get(this.baseUrl + 'login');
  }

  getUserProfile() {
    console.log(this.authService.isLoggedIn());
    if (this.authService.isLoggedIn()) {
      const token = this.authService.getAuthToken();
      if (token) {
        const requestData = {
          token: token
        };
        return axios.post(this.baseUrl + 'dashboard', requestData)
          .then(response => {
            return response.data;
          })
          .catch(error => {
            // Handle error
            console.error('Error fetching user profile:', error);
            throw error;
          });
      } else {
        // Token not available, logout user
        this.authService.logout();
        return Promise.reject('Token not available');
      }

    } else {
      return Promise.reject('User not logged in');
    }
  }
}
