import { Component } from '@angular/core';
import { ServiceBackend } from '../service-backend.service';
import { AuthService } from '../auth.service';
import { Router } from '@angular/router';
import { NgToastService } from 'ng-angular-popup';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent {

  email: string = '';
  password: string = '';

  constructor(private serviceBackend: ServiceBackend, private authService: AuthService, private router: Router,private toast:NgToastService) { }

  login() {
    const loginData = {
      email: this.email,
      password: this.password
    };

    this.serviceBackend.loginPost(loginData)
      .then(response => {
        console.log('Login successful:', response.data);
        if (response?.data?.token) {
          // If token is received from backend, set it in AuthService
          this.authService.setAuthToken(response.data.token);
          console.log(this.authService.getAuthToken());
          this.toast.success({detail:'Success',summary:'This is Success', position:'topRight',sticky:true})
          // Redirect to main page after successful login
          this.router.navigate(['/main']);
        } else {
          console.log("Token not received in response");
        }
      })
      .catch(error => {
        console.error('Login failed:', error);
      });
  }
}
