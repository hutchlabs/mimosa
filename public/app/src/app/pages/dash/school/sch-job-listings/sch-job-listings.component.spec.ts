/* tslint:disable:no-unused-variable */
import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { By } from '@angular/platform-browser';
import { DebugElement } from '@angular/core';

import { SchJobListingsComponent } from './sch-job-listings.component';

describe('SchJobListingsComponent', () => {
  let component: SchJobListingsComponent;
  let fixture: ComponentFixture<SchJobListingsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ SchJobListingsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(SchJobListingsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
