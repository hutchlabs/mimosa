import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-price-listings',
  templateUrl: './price-listings.component.html',
  styleUrls: ['./price-listings.component.css']
})
export class PriceListingsComponent implements OnInit {

  constructor() { }
  
  planOne:boolean = false;
  planTwo:boolean = false;
  planThree:boolean = true;
  planFour:boolean = false;

  ngOnInit() {
  }
  
  choosePlan(card:string) :void{
    switch (card){
      case "1":
          this.planOne = true;
          this.planTwo = false;
          this.planThree = false;
          this.planFour = false;
            break;
      case "2":
        this.planOne = false;
        this.planTwo = true;
        this.planThree = false;
        this.planFour = false;
            break;
      case "3":
        this.planOne = false;
        this.planTwo = false;
        this.planThree = true;
        this.planFour = false;
            break;
      case "4":
        this.planOne = false;
        this.planTwo = false;
        this.planThree = false;
        this.planFour = true;
            break;
      default:
            break;
    }
  }

}
