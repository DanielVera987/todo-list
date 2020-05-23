import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { NewEtiquetaComponent } from './new-etiqueta.component';

describe('NewEtiquetaComponent', () => {
  let component: NewEtiquetaComponent;
  let fixture: ComponentFixture<NewEtiquetaComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ NewEtiquetaComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(NewEtiquetaComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
