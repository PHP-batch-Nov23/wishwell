import { Injectable } from '@angular/core';
import { isPlatformBrowser } from '@angular/common';
import { PLATFORM_ID, Inject } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class AuthService {
    //test comment
  private readonly AUTH_TOKEN_KEY = 'authToken';

  constructor(@Inject(PLATFORM_ID) private platformId: Object) { }

  setAuthToken(token: string): void {
    // localStorage.setItem(this.AUTH_TOKEN_KEY, token);
  }

  // getAuthToken(): string | null {
  //   // return localStorage.getItem(this.AUTH_TOKEN_KEY);
  // }

  // isLoggedIn(): boolean {
  //   // return !!this.getAuthToken();
  // }

  logout(): void {
    // localStorage.removeItem(this.AUTH_TOKEN_KEY);
  }



}
