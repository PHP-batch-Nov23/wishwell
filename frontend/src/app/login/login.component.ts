// login.component.ts

import { Component } from '@angular/core';
import { ServiceBackend } from '../service-backend.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent {
  email: string = '';
  password: string = '';

  constructor(private serviceBackend : ServiceBackend) {  }

  login() {

    const loginData = {
      email: this.email,
      password: this.password
    };

    this.serviceBackend.loginPost(loginData)
      .then(response => {
        console.log('Login successful:', response);
      })
      .catch(error => {
        console.error('Login failed:', error);
      });

  }
}
