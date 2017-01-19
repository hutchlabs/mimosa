/* tslint:disable:no-unused-variable */
import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { By } from '@angular/platform-browser';
import { DebugElement } from '@angular/core';

import { StProfileComponent } from './st-profile.component';

describe('StProfileComponent', () => {
  let component: StProfileComponent;
  let fixture: ComponentFixture<StProfileComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ StProfileComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(StProfileComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
