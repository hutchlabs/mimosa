/* tslint:disable:no-unused-variable */
import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { By } from '@angular/platform-browser';
import { DebugElement } from '@angular/core';

import { JobListingsComponent } from './job-listings.component';

describe('JobListingsComponent', () => {
  let component: JobListingsComponent;
  let fixture: ComponentFixture<JobListingsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ JobListingsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(JobListingsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
