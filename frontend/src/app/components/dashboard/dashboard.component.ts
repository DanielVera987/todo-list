import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute, Params } from '@angular/router';
import { UserService } from '../../services/user.service';
import { TaskService } from '../../services/task.service';
import { Task } from '../../models/task';
import { Etiqueta } from '../../models/etiqueta';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css'],
  providers: [UserService, TaskService]
})
export class DashboardComponent implements OnInit {
  public status: String;
  public token;
  public identity;
  public etiqueta: Etiqueta;
  public task: Task;
  public tasks: Array<Task>;
  public etiquetas: Array<Etiqueta>;
  public statusTask: String;

  constructor(
    public _userService: UserService,
    public _taskService: TaskService,
    private _router : Router,
    private _route: ActivatedRoute
  ) { 
    this.identity = this._userService.getIdentity();
    this.token = this._userService.getToken();
    this.etiqueta = new Etiqueta (1, '', '');
    this.task = new Task(1, 1, 1, '', 0);
  }

  ngOnInit(): void {
    this.getTask();
    this.getEtiqueta();
  }

  onSubmit(form){
    this._taskService.newEtiqueta(this.token, this.etiqueta).subscribe(
      response => {
        if(response.status == 'success'){
          this.status = "success";
          this.getEtiqueta();
        }else{
          this.status = "error";
        }
      },
      error => {  
        console.log(<any>error);
      }
    );
  }

  onNewTask(form){
    this._taskService.newTask(this.token, this.task).subscribe(
      response => {
        if(response.status == 'success'){
          this.statusTask = 'success';
          this.getTask();
        }
      },
      error => {  
        console.log(<any>error);
      }
    );
  }

  deleteTask(id){
    this._taskService.deleteTask(this.token, id).subscribe(
      response => {
        if(response.status = "success"){
          this.getTask();
        }
      },
      error => {
        console.log(<any>error);
      }
    )
  }

  deleteEtiqueta(id){
    this._taskService.deleteEtiqueta(this.token, id).subscribe(
      response => {
        if(response.status = "success"){
          this.getEtiqueta();
        }
      },
      error => {
        console.log(<any>error);
      }
    )
  }

  getTask(){
    this._taskService.getTask(this.token).subscribe(
      response => {
        this.tasks = response.tasks;
      },
      error => {
        console.log(<any>error);
      }
    );
  }

  getEtiqueta(){
    this._taskService.getEtiqueta(this.token).subscribe(
      response => {
        this.etiquetas = response.etiquetas;
      },
      error => {
        console.log(<any>error);
      }
    );
  }

}
