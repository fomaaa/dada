import Vue from 'vue'
import Router from 'vue-router'
import MainComponent from '../pages/Main/Main'
import WorksComponent from '../pages/Works/Works'
import AgencyComponent from '../pages/Agency/Agency'
import CaseComponent from '../pages/Case/Case'

Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/:lang',
      component: {template: '<router-view/>'},
      children: [
        {
          path: '',
          name: 'MainComponent',
          component: MainComponent,
          children:
            [
              {
                path: 'agency',
                name: 'AgencyComponent',
                component: AgencyComponent
              },
              {
                path: 'works',
                name: 'WorksComponent',
                component: WorksComponent
              }
            ]
        }
      ]
    },
    {
      path: '/:lang/:case',
      name: 'CaseComponent',
      component: CaseComponent,
      transition: 'toCase'
    }
  ]
})


