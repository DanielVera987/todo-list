import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute, Params } from '@angular/router';
import { UserService } from '../../services/user.service';
import { User } from '../../models/user';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css'],
  providers: [UserService]
})
export class LoginComponent implements OnInit { 
  public user: User;
  public status: string;
  public token;
  public identity;

  constructor(
    private _userService: UserService,
    private _router : Router,
    private _route: ActivatedRoute
  ) {
    this.user = new User(1, '', '', '', '');
  }

  ngOnInit(): void {
  } 

  onSubmit(form){
    this._userService.login(this.user).subscribe(
      response => {
        if(response.status != 'error'){
          this.token = response;
          this.status = 'success';

          this._userService.login(this.user, true).subscribe(
            response => {
              this.identity = response;

              localStorage.setItem('token', this.token);
              localStorage.setItem('identity', JSON.stringify(this.identity));

              this._router.navigate(['/dashboard']);
            }, 
            error => {
              this.status = 'error';
              console.log(<any>error);
            }
          );
        }
      },
      error => {
        this.status = 'error';
        console.log(<any>error);
      }
    );
  }
}
