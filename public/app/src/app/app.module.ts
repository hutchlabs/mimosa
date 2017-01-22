import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpModule } from '@angular/http';
import { ModalModule } from 'angular2-modal';
import { BootstrapModalModule } from 'angular2-modal/plugins/bootstrap';

import { AppRoutingModule } from '../app/app-routing/app-routing.module';

import { AppComponent } from './app.component';
import { HomeComponent } from '../app/pages/main/home/home.component';
import { JobSearchComponent } from '../app/pages/main/job-search/job-search.component';
import { EmployerSearchComponent } from '../app/pages/main/employer-search/employer-search.component';
import { AppRoutingComponent } from '../app/app-routing/app-routing.component';
import { PageNotFoundComponent } from '../app/pages/main/page-not-found/page-not-found.component';
import { LoginComponent } from '../app/pages/main/login/login.component';
import { SignupComponent } from '../app/pages/main/signup/signup.component';
import { NavComponent } from '../app/pages/main/common/nav/nav.component';
import { ContactComponent } from '../app/pages/main/contact/contact.component';

import { AdminNavComponent } from '../app/pages/dash/admin/common/admin-nav/admin-nav.component';
import { SidebarComponent } from '../app/pages/dash/admin/common/sidebar/sidebar.component';
import { EmpSidebarComponent } from '../app/pages/dash/employer/common/emp-sidebar/emp-sidebar.component';
import { SchSidebarComponent } from '../app/pages/dash/school/common/sch-sidebar/sch-sidebar.component';
import { StdSidebarComponent } from '../app/pages/dash/student/common/std-sidebar/std-sidebar.component';

import { JobListingsComponent } from '../app/pages/dash/employer/job-listings/job-listings.component';
import { PriceListingsComponent } from '../app/pages/dash/employer/price-listings/price-listings.component';
import { ProfileComponent } from '../app/pages/dash/employer/profile/profile.component';
import { EventsComponent } from '../app/pages/dash/employer/events/events.component';
import { EmpDashboardComponent } from '../app/pages/dash/employer/emp-dashboard/emp-dashboard.component';
import { StDashboardComponent } from '../app/pages/dash/student/st-dashboard/st-dashboard.component';
import { StProfileComponent } from '../app/pages/dash/student/st-profile/st-profile.component';
import { StSettingsComponent } from '../app/pages/dash/student/st-settings/st-settings.component';
import { ScDashboardComponent } from '../app/pages/dash/school/sc-dashboard/sc-dashboard.component';
import { EmpNavComponent } from './pages/dash/employer/common/emp-nav/emp-nav.component';
import { EmployerRoutingComponent } from './employer-routing/employer-routing.component';
import { EmpHomeComponent } from './pages/dash/employer/emp-home/emp-home.component';
import { EmpSettingsComponent } from './pages/dash/employer/emp-settings/emp-settings.component';
import { SchHomeComponent } from './pages/dash/school/sch-home/sch-home.component';
import { SchSettingsComponent } from './pages/dash/school/sch-settings/sch-settings.component';
import { SchProfileComponent } from './pages/dash/school/sch-profile/sch-profile.component';
import { SchStudentsComponent } from './pages/dash/school/sch-students/sch-students.component';
import { SchJobListingsComponent } from './pages/dash/school/sch-job-listings/sch-job-listings.component';

import { AuthService } from '../app/pages/main/login/auth.service';
import { AdminDashboardComponent } from './pages/dash/admin/admin-dashboard/admin-dashboard.component';
import { AdminSchoolsComponent } from './pages/dash/admin/admin-schools/admin-schools.component';
import { AdminEmployersComponent } from './pages/dash/admin/admin-employers/admin-employers.component';
import { AdminSettingsComponent } from './pages/dash/admin/admin-settings/admin-settings.component';
import { AdminJobsComponent } from './pages/dash/admin/admin-jobs/admin-jobs.component';
import { AdminCMSComponent } from './pages/dash/admin/admin-cms/admin-cms.component';
import { AdminHomeComponent } from './pages/dash/admin/admin-home/admin-home.component';
import { SchoolsComponent } from './pages/main/schools/schools.component';
import { SchPricesComponent } from './pages/dash/school/sch-prices/sch-prices.component';
import { StHomeComponent } from './pages/dash/student/st-home/st-home.component';
import { StJobsComponent } from './pages/dash/student/st-jobs/st-jobs.component';
import { StEmployerComponent } from './pages/dash/student/st-employer/st-employer.component';

import { InAppModalModule } from './pages/main/common/modal-plugin/index';

@NgModule({
  declarations: [
    AppComponent,
    HomeComponent,
    JobSearchComponent,
    EmployerSearchComponent,
    AppRoutingComponent,
    PageNotFoundComponent,
    LoginComponent,
    SignupComponent,
    NavComponent,
    ContactComponent,
    AdminNavComponent,
    SidebarComponent,
    EmpSidebarComponent,
    SchSidebarComponent,
    StdSidebarComponent,
    JobListingsComponent,
    PriceListingsComponent,
    ProfileComponent,
    EventsComponent,
    EmpDashboardComponent,
    StDashboardComponent,
    StProfileComponent,
    StSettingsComponent,
    ScDashboardComponent,
    EmpNavComponent,
    EmployerRoutingComponent,
    EmpHomeComponent,
    EmpSettingsComponent,
    SchHomeComponent,
    SchSettingsComponent,
    SchProfileComponent,
    SchStudentsComponent,
    SchJobListingsComponent,
    AdminDashboardComponent,
    AdminSchoolsComponent,
    AdminEmployersComponent,
    AdminSettingsComponent,
    AdminJobsComponent,
    AdminCMSComponent,
    AdminHomeComponent,
    SchoolsComponent,
    SchPricesComponent,
    StHomeComponent,
    StJobsComponent,
    StEmployerComponent,
  ],
  imports: [
    BrowserModule,
    FormsModule,
    HttpModule,
    ModalModule.forRoot(),
    BootstrapModalModule,
    InAppModalModule,
    AppRoutingModule
  ],
  providers: [AuthService],
  bootstrap: [AppComponent]
})
export class AppModule { }
