import { Component, OnInit } from '@angular/core';
import { ServiceBackend } from '../service-backend.service';
import { Router } from '@angular/router';
import { AuthService } from '../auth.service';
@Component({
  selector: 'app-main',
  templateUrl: './main.component.html',
  styleUrls: ['./main.component.css']
})
export class MainComponent implements OnInit {

  campaigns: any = [];

  constructor(private serviceBackend: ServiceBackend, private router: Router,private authService: AuthService) {}

  ngOnInit(): void {
    this.getCampaigns();
  }

  getCampaigns() {
    this.serviceBackend.getAllActiveCampaigns()
      .then(data => {
        this.campaigns = data.data; // Assuming data is an array of campaigns
        console.log(this.campaigns);
      })
      .catch(error => {
        console.error('Error fetching campaigns:', error);
      });
  }

  goToDetailsPage(id:string) {
    if (this.authService.isLoggedIn()) {
      // User is logged in, navigate to details page
      this.router.navigate(['/details/'+id]);
    } else {
      // User is not logged in, navigate to login page
      this.router.navigate(['/login']);
    }
  }


}
