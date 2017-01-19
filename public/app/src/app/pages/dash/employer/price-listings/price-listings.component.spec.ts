/* tslint:disable:no-unused-variable */
import { async, ComponentFixture, TestBed } from '@angular/core/testing';
import { By } from '@angular/platform-browser';
import { DebugElement } from '@angular/core';

import { PriceListingsComponent } from './price-listings.component';

describe('PriceListingsComponent', () => {
  let component: PriceListingsComponent;
  let fixture: ComponentFixture<PriceListingsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ PriceListingsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(PriceListingsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
