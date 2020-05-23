import { Injectable } from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import {Observable} from 'rxjs';
import {global} from './global';
import {User} from '../models/user';

@Injectable()
export class UserService {
  public url: string;
  public identity;
  public token;

  constructor(
    public _http: HttpClient
  ){
    this.url = global.url;
  }

  login(user, getToken = null): Observable<any>{
    if(getToken != null){
      user.gettoken = 'true';
    }

    let json = JSON.stringify(user);
    let params = 'json=' + json;
    let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');

    //Realizamos la peticion ajax
    return this._http.post(this.url + 'login', params, {headers: headers});
  }

  register(user): Observable<any>{
    let json = JSON.stringify(user);
    let params = "json="+json;
    let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');

    return this._http.post(this.url + 'registro', params, {headers:headers});
  }

  getIdentity(){
    let identity = JSON.parse(localStorage.getItem('identity'));

    if(identity && identity != "Undefined"){
          this.identity = identity;
    }else{
          this.identity = null;
    }

    return this.identity;
  }

  getToken(){
    let token = localStorage.getItem('token');

    if(token && token != "Undefined"){
      this.token = token;
    }else{
      this.token = null;
    }

    return this.token;
  }
}
