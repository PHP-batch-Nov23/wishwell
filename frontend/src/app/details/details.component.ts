import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { ServiceBackend } from '../service-backend.service';
@Component({
  selector: 'app-details',
  templateUrl: './details.component.html',
  styleUrls: ['./details.component.css']
})
export class DetailsComponent implements OnInit {
  campaignId: string='';
  campaign :any ={}; 

  constructor(private route: ActivatedRoute,private serviceBackend :ServiceBackend) {}

  ngOnInit(): void {
    this.route.params.subscribe(params => {

      this.campaignId = params['id'];
      console.log(this.campaignId);

      this.campaign = this.serviceBackend.getCampaignById(this.campaignId).then(
        data=> {
          this.campaign = data.data
          console.log(this.campaign)
        })


      
    });
  }
}
