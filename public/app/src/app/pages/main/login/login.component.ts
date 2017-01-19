import { Component, OnInit } from '@angular/core';

import { Router }      from '@angular/router';
import { AuthService } from './auth.service';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  ngOnInit() {
  }

  message: string;
  constructor(public authService: AuthService, public router: Router) {
    this.setMessage();
  }
  setMessage() {
    this.message = 'Logged ' + (this.authService.isLoggedIn ? 'in' : 'out');
  }
  
  login(username:string,password:string) {
    this.message = 'Trying to log in ...';
    this.authService.login().subscribe(() => {
      this.setMessage();
      if (this.authService.isLoggedIn) {
       let url:string;

          // Get the redirect URL from our auth service
        // If no redirect has been set, use the default
        if(username === 'admin') {
          url = '/admin';
        }else if(username === 'student') {
          url = '/student';
        }else if(username === 'employer'){
          url = '/recruiter';
        }else if(username === 'school'){
          url = '/school';
        }
        let redirect = this.authService.redirectUrl ? this.authService.redirectUrl : url;
        // Redirect the user
        this.router.navigate([url]);
      }
    });
  }
  logout() {
    this.authService.logout();
    this.setMessage();
  }

}
