import { Component, OnInit } from '@angular/core';
import { Http, Response } from '@angular/http';
import { Observable } from 'rxjs/Rx';

import 'rxjs/add/operator/map';
import 'rxjs/add/operator/catch';

@Component({
  selector: 'app-home',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.css']
})

export class HomeComponent implements OnInit {

    featuredJobs = [];
    featuredCompanies = [];
  
    ngOnInit() {
    }

    constructor(private http: Http) {
        this.getFeaturedJobsAndCompanies();
    }
    
    getFeaturedJobsAndCompanies() {
        Observable.forkJoin(
            this.http.get('/mimosa/api/jobs/featured').map(response => response.json()),
            this.http.get('/mimosa/api/organizations/featured').map(response => response.json())
        ).subscribe(
            data => {
                this.featuredJobs = data[0].data;
                this.featuredCompanies = data[1].data;
            },
            err => { console.error(err); }
        );
    }
    
}
