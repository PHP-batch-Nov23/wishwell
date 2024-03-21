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

    const logedin = this.serviceBackend.loginPost({
      email:"g@gmail.com",
      password:"12345"
    })
    
    console.log(logedin)

  }
}
