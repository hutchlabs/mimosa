import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes }  from '@angular/router';
import { HashLocationStrategy, LocationStrategy } from '@angular/common';


import { JobListingsComponent } from '../pages/dash/employer/job-listings/job-listings.component';
import { PriceListingsComponent } from '../pages/dash/employer/price-listings/price-listings.component';
import { ProfileComponent } from '../pages/dash/employer/profile/profile.component';
import { EventsComponent } from '../pages/dash/employer/events/events.component';
import { EmpDashboardComponent } from '../pages/dash/employer/emp-dashboard/emp-dashboard.component';
import { StDashboardComponent } from '../pages/dash/student/st-dashboard/st-dashboard.component';
import { StProfileComponent } from '../pages/dash/student/st-profile/st-profile.component';
import { StSettingsComponent } from '../pages/dash/student/st-settings/st-settings.component';
import { ScDashboardComponent } from '../pages/dash/school/sc-dashboard/sc-dashboard.component';
import { EmpHomeComponent } from '../pages/dash/employer/emp-home/emp-home.component';

import { EmployerRoutingComponent } from './employer-routing.component';


const childRoutes: Routes = [
  {
    path: 'recruiter', component: EmpDashboardComponent ,
    children: [
          { path: '',   redirectTo: 'dashboard', pathMatch: 'full' },
          { path: 'dashboard', component: EmpHomeComponent },
          { path: 'listings', component: JobListingsComponent },
          { path: 'prices', component: PriceListingsComponent },
          { path: 'profile', component: ProfileComponent },
          { path: 'events', component: EventsComponent }
    ]
  }
];

@NgModule({
  imports: [
    RouterModule.forChild(childRoutes),
    CommonModule
  ],
  declarations: [],
  exports: [
    RouterModule
  ],
  providers: [{provide: LocationStrategy, useClass: HashLocationStrategy}]

})
export class EmployerRoutingModule { }
