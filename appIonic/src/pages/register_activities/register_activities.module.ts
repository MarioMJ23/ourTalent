import { NgModule } from '@angular/core';
import { IonicPageModule } from 'ionic-angular';
import { RegisterActivitiesPage } from './register_activities';

@NgModule({
  declarations: [
    RegisterActivitiesPage,
  ],
  imports: [
    IonicPageModule.forChild(RegisterActivitiesPage),
  ],
})
export class RegisterActivitiesPageModule {}
