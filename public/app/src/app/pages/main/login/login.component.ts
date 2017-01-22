import { Component, OnInit, ViewEncapsulation, ViewChild, TemplateRef } from '@angular/core';
import { InAppModalModule, Modal } from '../common/modal-plugin/index';

import { Router }      from '@angular/router';
import { AuthService } from './auth.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css'],
  providers: InAppModalModule.getProviders(),
  encapsulation: ViewEncapsulation.None
})
export class LoginComponent implements OnInit {

@ViewChild('myTemplate', {read: TemplateRef}) public myTemplate: TemplateRef<any>;

  ngOnInit() {
  }

  error: boolean = false;
  loggingIn: boolean = false;
  
  constructor(public authService: AuthService, public router: Router, private modal: Modal) {
  }
  
  ngAfterViewInit() {
    this.modal.alert()
      .title('Login to Continue...')
      .templateRef(this.myTemplate)
      .inElement(true)
      .open('home-overlay-container')
      .then(d => d.result)
      .catch((e) => {
        console.log('This message should appear if you navigate away from the home page.');
        console.log('If a modal is opened in a view container within a component that is the page or' +
          'part of the page, navigation will destroy the page thus destroy the modal. To prevent ' +
          'memory leaks and unexpected behavior a "DialogBailOutError" error is thrown.');
        console.log(e);
      });
  }

  login(username:string, password:string) {
    this.error = false;
    this.loggingIn = true;
    
    this.authService.login(username, password)
        .subscribe(
            response => {
                this.loggingIn = false;
                
                this.authService.user = response.data;
                this.authService.isLoggedIn = true;
                
                let url:string;

                // Get the redirect URL from our auth service
                // If no redirect has been set, use the default
                if(this.authService.user.type == 'gradlead') {
                  url = '/admin';
                }else if(this.authService.user.type == 'student' || this.authService.user.type=='graduate') {
                  url = '/student';
                }else if(this.authService.user.type == 'employer'){
                  url = '/recruiter';
                }else if(this.authService.user.type == 'school'){
                  url = '/school';
                }

                let redirect = url ? url : this.authService.redirectUrl;

                this.router.navigate([redirect]);
            },
            err => {
                this.loggingIn = false;
                this.error = true;
                console.error(err); 
            }
        );
  }
  logout() {
    this.authService.logout().subscribe(
            () => {     
                this.authService.isLoggedIn = false;
                this.router.navigate([this.authService.redirectUrl]);
    });
  }

}
