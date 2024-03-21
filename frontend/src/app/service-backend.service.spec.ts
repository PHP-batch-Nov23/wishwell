import { TestBed } from '@angular/core/testing';

import { ServiceBackendService } from './service-backend.service';

describe('ServiceBackendService', () => {
  let service: ServiceBackendService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ServiceBackendService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
