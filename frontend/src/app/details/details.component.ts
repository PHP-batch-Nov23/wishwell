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
  donationAmount: number = 50 ;

  constructor(private route: ActivatedRoute,private serviceBackend :ServiceBackend) {}

  ngOnInit(): void {
    this.route.params.subscribe(params => {

      this.campaignId = params['id'];
      // current_amount_add
      this.campaign = this.serviceBackend.getCampaignById(this.campaignId).then(
        data=> {
          this.campaign = data.data;
        })
      
    });
  }




  donate(): void {
    // Perform donation processing here
    // You can send donationAmount to a server or perform any other action as needed
    // For now, let's just log the donation amount
    this.serviceBackend.getUser().then(data=>{

      if(this.donationAmount>data.data.balance){

        console.log("insufficient Balance Recharge your wallet ") ;

      }else{
        this.serviceBackend.updateUser({'balance':data.data.balance-this.donationAmount}).then(data=>console.log(data));
        this.serviceBackend.updateCampaignCurrentAmount({'current_amount_add':this.donationAmount,'id':this.campaignId}).then(data=>this.campaign=data.data)

        console.log(data.data);

        this.serviceBackend.createDonationEntry({"donor_id":data.data.id,"campaign_id":this.campaignId,"amount":this.donationAmount}).then(data=>console.log(data))

        console.log('Thank you for your donation of $', this.donationAmount);
      }
    })


    
  }



}
