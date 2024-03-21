// profile.component.ts
import { Component } from '@angular/core';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css']
})
export class ProfileComponent {

  selectedOption: string = 'profile'; 
  
  userProfile: any = { 
    name: 'John Doe',
    email: 'john@example.com',
    dob: '1990-01-01',
    sex: 'Male',
    age: 30,
    cause:"xyz",
    pan: 'ABCPD1234F',
    balance: 1000,
    address: '123 Main St',
    city: 'Anytown',
    role: 'Donor',
    description: 'Lorem ipsum',
  }; 
  
  editMode: any = {}; // Object to track edit mode for each field
  donations: any[] = ['Donation 1', 'Donation 2', 'Donation 3']; // Example donations data
  totalBalance: number = 1000; // Example total balance
  campaignData: any;

  showProfile() {
    this.selectedOption = 'profile';
  }

  showDonations() {
    this.selectedOption = 'donations';
  }

  showBalance() {
    this.selectedOption = 'balance';
  }

  showMyCampaigns() {
    this.selectedOption = 'myCampaigns';
  }

 


  toggleEditMode(field: string) {
    this.editMode[field] = !this.editMode[field];
  }

  saveChanges(field: string) {
    // Implement save changes logic here
    this.toggleEditMode(field);
  }

  cancelEdit(field: string) {
    // Implement cancel edit logic here
    this.toggleEditMode(field);
  }

  CreateCampaign() {
    this.selectedOption = 'CreateCampaign';
  }

  createCampaign() {
    // Add logic to handle form submission and campaign creation
    console.log('Campaign created with data:', this.campaignData);
    // Reset the form after submission
    this.resetForm();
    // Switch back to the default view after campaign creation
    this.showBalance(); // Change to whichever default view you prefer
  }

  cancelCreateCampaign() {
    // Reset the form and switch back to the default view
    this.resetForm();
    this.showBalance(); // Change to whichever default view you prefer
  }

  resetForm() {
    // Reset campaign data
    this.campaignData = {
      cause: '',
      title: '',
      description: '',
      goalAmount: null,
      startDate: null,
      endDate: null,
      beneficiaryName: '',
      beneficiaryAge: null,
      beneficiaryCity: '',
      beneficiaryMobile: ''
    };
  }
}


