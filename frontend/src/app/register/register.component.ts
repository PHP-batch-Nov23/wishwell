// register.component.ts

import { Component } from '@angular/core';

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
  city: string = '';
  password: string = '';

  constructor() { }

  register() {
    // Your registration logic goes here
    console.log('Registration form submitted');
    console.log('Selected Role:', this.selectedRole);
    console.log('Name:', this.name);
    console.log('Email:', this.email);
    console.log('Date of Birth:', this.dob);
    console.log('Sex:', this.sex);
    console.log('PAN:', this.pan);
    console.log('Address:', this.address);
    console.log('City:', this.city);
    console.log('Password:', this.password);
  }
}
