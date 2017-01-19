/* tslint:disable:no-unused-variable */
import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { By } from '@angular/platform-browser';
import { DebugElement } from '@angular/core';

import { StJobsComponent } from './st-jobs.component';

describe('StJobsComponent', () => {
  let component: StJobsComponent;
  let fixture: ComponentFixture<StJobsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ StJobsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(StJobsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
