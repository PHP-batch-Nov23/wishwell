import { Injectable } from '@angular/core';
import axios from 'axios';

@Injectable({
  providedIn: 'root'
})
export class ServiceBackend {

  baseUrl = 'http://127.0.0.1:8000/api/'; 
  constructor() {}

  get(url: string) {
    return axios.get(this.baseUrl+'register');
  }

  registerPost( data: any) {
    return axios.post(this.baseUrl+'register', data);
  }

  // Other HTTP methods as needed
}

