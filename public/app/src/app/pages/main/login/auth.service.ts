import { Injectable } from '@angular/core';
import { Http, Response } from '@angular/http';


import { Observable } from 'rxjs/Observable';
import 'rxjs/add/observable/of';
import 'rxjs/add/operator/do';
import 'rxjs/add/operator/delay';
import 'rxjs/add/operator/map';


@Injectable()
export class AuthService {

  constructor(private http: Http) { 
    this.redirectUrl = '/';
  }

  redirectUrl: string;
  
  user = {type:''};
  isLoggedIn: boolean = false;

  register(type:string, name:string, username:string, password:string): Observable<any> {
     return this.http
                .post('/mimosa/api/fregister',{'type':type, 'name': name, 'email': username, 'password': password})
                .map(response => response.json());
  }

  login(username:string, password:string): Observable<any> {
     return this.http
                .post('/mimosa/api/flogin',{'email': username, 'password': password})
                .map(response => response.json());
  }

  logout(): Observable<any> {
    return this.http.post('/mimosa/api/flogout',{}).map(response => response.json());
  }
}
