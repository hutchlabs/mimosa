import { Component, OnInit, ViewEncapsulation, ViewChild, TemplateRef } from '@angular/core';
import { InAppModalModule, Modal } from '../common/modal-plugin/index';

import { Router }      from '@angular/router';
import { AuthService } from '../login/auth.service';

@Component({
  selector: 'app-signup',
  templateUrl: './signup.component.html',
  styleUrls: ['./signup.component.css'],
  providers: InAppModalModule.getProviders(),
  encapsulation: ViewEncapsulation.None
})

export class SignupComponent implements OnInit {
  
  @ViewChild('myTemplate', {read: TemplateRef}) public myTemplate: TemplateRef<any>;
  
  error: boolean = false;
  signingUp: boolean = false;
  
  ngOnInit() {
  }
  
  constructor(public authService: AuthService, public router: Router, private modal: Modal) {
  }
  
  ngAfterViewInit() {
    this.modal.alert()
      .title('Sign Up!')
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

  signup(type:string, name:string, username:string, password:string) {
    this.error = false;
    this.signingUp = true;
    
    this.authService.register(type, name, username, password)
        .subscribe(
            response => {
                this.signingUp = false;
                
                this.authService.user = response.data;
                this.authService.isLoggedIn = true;
                
                let url:string;

                if(this.authService.user.type == 'student' || this.authService.user.type=='graduate') {
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
                this.signingUp = false;
                this.error = true;
                console.error(err); 
            }
        );
  }
  
  cancel() {
    this.router.navigate(['/']);
  }

}
