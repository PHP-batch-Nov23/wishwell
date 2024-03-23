import { Component, OnInit } from '@angular/core';
import { ServiceBackend } from '../service-backend.service';
import { AuthService } from '../auth.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css']
})
export class ProfileComponent implements OnInit {
  selectedOption: string = 'profile';
  userProfile: any;
  editMode: any = {}; // Object to track edit mode for each field
  donations: any[] = ['Donation 1', 'Donation 2', 'Donation 3']; // Example donations data
  totalBalance: number = 1000; // Example total balance
  campaignData: any;

  constructor(private router: Router,private serviceBackend: ServiceBackend, private authService: AuthService) {}

  ngOnInit(): void {
    this.showProfile();
  }

  showProfile() {
    this.serviceBackend.getUserProfile()
      .then(userProfile => {
        console.log(userProfile.userData);
        this.userProfile = userProfile.userData;
      })
      .catch(error => {
        console.error('Error fetching user profile:', error);
      });
  }

  showDonations() {
    this.selectedOption = 'donations';
  }

  showBalance() {
    this.totalBalance = this.userProfile.balance;
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

  logout() {
    this.authService.logout();
    this.router.navigate(['/login']); 
    // Additional logic if needed after logout, e.g., redirect to login page
  }
}
