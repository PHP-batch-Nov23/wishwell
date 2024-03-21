// register.component.ts

import { Component } from '@angular/core';
import { ServiceBackend } from '../service-backend.service';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css']
})
export class RegisterComponent {
  selectedRole: string = 'donor'; // Set the default role to 'donor'
  name: string = '';
  email: string = '';
  dob: string = '';
  sex: string = '';
  pan: string = '';
  address: string = '';
  city: string = 'NA';
  password: string = '';

  constructor(private serviceBackend : ServiceBackend) {  }

  register() {

    const data = this.serviceBackend.registerPost({
      "name": "Donor",
      "email": "agdaa56565@example.com",
      "password": "password123",
      "role": "fundraiser",
      "sex": "male",
      "dob": "1990-01-01",
     });
     console.log(data)



  }
}
