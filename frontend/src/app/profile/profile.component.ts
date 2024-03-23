import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { ServiceBackend } from '../service-backend.service';
import { AuthService } from '../auth.service';

@Component({
  selector: 'app-profile',
  templateUrl: './profile.component.html',
  styleUrls: ['./profile.component.css']
})
export class ProfileComponent implements OnInit {
  selectedOption: string = 'profile';
  userProfile: any={};
  editMode: any = {}; // Object to track edit mode for each field
  donations: any[] = ['Donation 1', 'Donation 2', 'Donation 3']; // Example donations data
  totalBalance: number = 1000; // Example total balance
  campaignData: any={
    cause: '',
    title: '',
    description: '',
    goal_amount: null,
    start_date: null,
    end_date: null,
    beneficiary_name: '',
    beneficiary_age: null,
    beneficiary_city: '',
    beneficiary_mobile: ''
  };
  userCampaigns:any=[];

  constructor(private router: Router, private serviceBackend: ServiceBackend, private authService: AuthService) {}

  ngOnInit(): void {
    this.showProfile();
  }

  showProfile() {
    this.serviceBackend.getUserProfile()
      .then(userProfile => {
        console.log(userProfile);

        console.log(userProfile.userData);
        this.userProfile = userProfile.userData;
      })
      .catch(error => {
        console.error('Error fetching user profile:', error);
      });
  }


  profile(){
    this.selectedOption = 'profile';
  }

  showDonations() {
    this.selectedOption = 'donations';
  }

  showBalance() {
    this.selectedOption = 'balance';
    this.totalBalance = this.userProfile.balance;
  }

  showMyCampaigns() {
    this.selectedOption = 'myCampaigns';
    this.serviceBackend.getAllCampaignBySameUserId().then(data=>{
      this.userCampaigns= data.data.campaigns;
      });
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

  createCampaignEntry() {
    // Add logic to handle form submission and campaign creation
    console.log('Campaign created with data:', this.campaignData);

    let data = this.serviceBackend.createCampaign(this.campaignData).then(response => {
      console.log('camp creation successful:', response);  
    });
    


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
    this.router.navigate(['/login']); // Redirect to the login page after logout
  }
}
