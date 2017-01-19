import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-job-listings',
  templateUrl: './job-listings.component.html',
  styleUrls: ['./job-listings.component.css']
})
export class JobListingsComponent implements OnInit {

  constructor() { }

  isOnlineActive:boolean = true;
  isProfileActive:boolean = false;
  isDraftActive:boolean = false;
  isDeclinedActive:boolean = false;
  isExpiredActive:boolean = false;

  ngOnInit() {
  }

  tabChange(tabname: string): void{

    switch (tabname){

      case "online":
        this.isOnlineActive = true;
        this.isProfileActive = false;
        this.isDraftActive = false;
        this.isDeclinedActive = false;
        this.isExpiredActive = false;
        break;
      case "pending":
        this.isProfileActive = true;
        this.isOnlineActive = false;
        this.isDraftActive = false;
        this.isDeclinedActive = false;
        this.isExpiredActive = false;
        break;
      case "draft":
        this.isDraftActive = true;
        this.isProfileActive = false;
        this.isOnlineActive = false;
        this.isDeclinedActive = false;
        this.isExpiredActive = false;
        break;
      case "declined":
        this.isDeclinedActive = true;
        this.isProfileActive = false;
        this.isOnlineActive = false;
        this.isDraftActive = false;
        this.isExpiredActive = false;
        break;
      case "expired":
        this.isExpiredActive = true;
        this.isProfileActive = false;
        this.isOnlineActive = false;
        this.isDraftActive = false;
        this.isDeclinedActive = false;
        break;
      default :
        break;
    }
  }


}
