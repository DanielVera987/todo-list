import { Injectable } from '@angular/core';
import {HttpClient, HttpHeaders} from '@angular/common/http';
import {Observable} from 'rxjs';
import {global} from './global';
import {Task} from '../models/task';

@Injectable()
export class TaskService {
    public url: string;
    public identity;
    public token;

    constructor(
        public _http: HttpClient
    ){
        this.url = global.url;
    }

    getTask(token): Observable<any>{
        let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded')
                                       .set('Authorization', token);

        return this._http.get(this.url + 'task', {headers:headers});
    }

    newTask(token, tarea): Observable<any>{
        let json = JSON.stringify(tarea);
        let params = "json=" + json;
        let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded')
                                       .set('Authorization', token);

        return this._http.post(this.url + 'task', params, {headers: headers});
    }

    deleteTask(token, id): Observable<any>{
        let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded')
                                        .set('Authorization', token);

        return this._http.delete(this.url + 'task/' + id, {headers: headers});
    }

    getEtiqueta(token): Observable<any>{
        let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded')
                                       .set('Authorization', token);

        return this._http.get(this.url + 'etiqueta', {headers:headers});
    }

    newEtiqueta(token, etiqueta): Observable<any>{
        let json = JSON.stringify(etiqueta);
        let params = "json=" + json;
        let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded')
                                       .set('Authorization', token);

        return this._http.post(this.url + 'etiqueta', params, {headers: headers});
    }

    deleteEtiqueta(token, id): Observable<any>{
        let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded')
                                        .set('Authorization', token);

        return this._http.delete(this.url + 'etiqueta/' + id, {headers: headers});
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
}