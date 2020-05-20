import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute, Params } from '@angular/router';
import { UserService } from '../../services/user.service';
import { User } from '../../models/user';

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css'],
  providers: [UserService]
})
export class RegisterComponent implements OnInit {
  public user: User;
  public status: String;
  public token;
  public identity;

  constructor(
    public _userService: UserService,
    private _router : Router,
    private _route: ActivatedRoute
  ) { 
    this.user = new User(1, '', '', '', '');
  }

  ngOnInit(): void {
  }

  onSubmit(form){
    this._userService.register(this.user).subscribe(
      response => {
        console.log(response);
      },
      error => {
        console.log(<any>error);
      }
    );
  }

}
