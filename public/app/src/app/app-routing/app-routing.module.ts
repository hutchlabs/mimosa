import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, Routes }  from '@angular/router';
import { HashLocationStrategy, LocationStrategy } from '@angular/common';

import { HomeComponent } from '../pages/main/home/home.component';
import { JobSearchComponent } from '../pages/main/job-search/job-search.component';
import { EmployerSearchComponent } from '../pages/main/employer-search/employer-search.component';
import { PageNotFoundComponent } from '../pages/main/page-not-found/page-not-found.component';
import { LoginComponent } from '../pages/main/login/login.component';
import { SignupComponent } from '../pages/main/signup/signup.component';
import { ContactComponent } from '../pages/main/contact/contact.component';
import { SchoolsComponent } from '../pages/main/schools/schools.component';

import { JobListingsComponent } from '../pages/dash/employer/job-listings/job-listings.component';
import { PriceListingsComponent } from '../pages/dash/employer/price-listings/price-listings.component';
import { ProfileComponent } from '../pages/dash/employer/profile/profile.component';
import { EventsComponent } from '../pages/dash/employer/events/events.component';
import { EmpDashboardComponent } from '../pages/dash/employer/emp-dashboard/emp-dashboard.component';
import { EmpHomeComponent } from '../pages/dash/employer/emp-home/emp-home.component';

import { StDashboardComponent } from '../pages/dash/student/st-dashboard/st-dashboard.component';
import { StProfileComponent } from '../pages/dash/student/st-profile/st-profile.component';
import { StSettingsComponent } from '../pages/dash/student/st-settings/st-settings.component';
import { StHomeComponent } from '../pages/dash/student/st-home/st-home.component';
import { StJobsComponent }  from '../pages/dash/student/st-jobs/st-jobs.component';
import { StEmployerComponent } from '../pages/dash/student/st-employer/st-employer.component';

import { EmployerRoutingComponent } from '../employer-routing/employer-routing.component';

import { AdminCMSComponent} from '../pages/dash/admin/admin-cms/admin-cms.component';
import { AdminDashboardComponent } from '../pages/dash/admin/admin-dashboard/admin-dashboard.component';
import { AdminEmployersComponent } from '../pages/dash/admin/admin-employers/admin-employers.component';
import { AdminJobsComponent } from '../pages/dash/admin/admin-jobs/admin-jobs.component';
import { AdminSchoolsComponent } from '../pages/dash/admin/admin-schools/admin-schools.component';
import { AdminSettingsComponent } from '../pages/dash/admin/admin-settings/admin-settings.component';
import { AdminHomeComponent }  from '../pages/dash/admin/admin-home/admin-home.component';

import { ScDashboardComponent } from '../pages/dash/school/sc-dashboard/sc-dashboard.component';
import { SchHomeComponent } from '../pages/dash/school/sch-home/sch-home.component';
import { SchJobListingsComponent } from '../pages/dash/school/sch-job-listings/sch-job-listings.component';
import { SchProfileComponent } from '../pages/dash/school/sch-profile/sch-profile.component';
import { SchSettingsComponent } from '../pages/dash/school/sch-settings/sch-settings.component';
import { SchStudentsComponent } from '../pages/dash/school/sch-students/sch-students.component';
import { SchPricesComponent } from '../pages/dash/school/sch-prices/sch-prices.component';


import { AuthGuardService } from '../pages/main/login/auth-guard.service';


const appRoutes: Routes = [

  { path: '',   redirectTo: '/home', pathMatch: 'full' },
  { path: 'home', component: HomeComponent },
  { path: 'jobs', component: JobSearchComponent },
  { path: 'employers', component: EmployerSearchComponent },
  { path: 'login', component: LoginComponent },
  { path: 'signup', component: SignupComponent },
  { path: 'contact', component: ContactComponent },
  { path: 'schools', component: SchoolsComponent },

  { path: 'admin', canActivate: [AuthGuardService], component: AdminDashboardComponent ,
    children: [
      { path: '',   redirectTo: 'dashboard', pathMatch: 'full' },
      { path: 'dashboard', component: AdminHomeComponent },
      { path: 'schools', component: AdminSchoolsComponent },
      { path: 'employers', component: AdminEmployersComponent },
      { path: 'jobs', component: AdminJobsComponent },
      { path: 'cms', component: AdminCMSComponent },
      { path: 'settings', component: AdminSettingsComponent }
    ]},
  { path: 'student',canActivate: [AuthGuardService], component: StDashboardComponent  ,
    children: [
      { path: '',   redirectTo: 'dashboard', pathMatch: 'full' },
      { path: 'dashboard', component: StHomeComponent },
      { path: 'profile', component: StProfileComponent },
      { path: 'settings', component: StSettingsComponent },
      { path: 'jobs', component: StJobsComponent },
      { path: 'employers', component: StEmployerComponent }
    ]},
  { path: 'school',canActivate: [AuthGuardService], component: ScDashboardComponent  ,
    children: [
      { path: '',   redirectTo: 'dashboard', pathMatch: 'full' },
      { path: 'dashboard', component: SchHomeComponent },
      { path: 'listings', component: SchJobListingsComponent },
      { path: 'prices', component: SchPricesComponent },
      { path: 'profile', component: SchProfileComponent },
      { path: 'students', component: SchStudentsComponent },
      { path: 'settings', component: SchSettingsComponent }

    ]},
  { path: 'recruiter',canActivate: [AuthGuardService], component: EmpDashboardComponent  ,
    children: [
      { path: '',   redirectTo: 'dashboard', pathMatch: 'full' },
      { path: 'dashboard', component: EmpHomeComponent },
      { path: 'listings', component: JobListingsComponent },
      { path: 'prices', component: PriceListingsComponent },
      { path: 'profile', component: ProfileComponent },
      { path: 'events', component: EventsComponent }
    ]
  },
    
  { path: '**', component: PageNotFoundComponent }

];

@NgModule({
  imports: [
    RouterModule.forRoot(appRoutes),
    CommonModule
  ],
  exports: [
    RouterModule
  ],
  declarations: [],
  providers: [AuthGuardService,{provide: LocationStrategy, useClass: HashLocationStrategy}]
})
export class AppRoutingModule { }
