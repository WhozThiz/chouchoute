/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const crmRoutes = {
  path: '/crm',
  component: Layout,
  redirect: '/crm',
  name: 'CRM',
  meta: {
    title: 'crm',
    icon: 'paw',
    permissions: ['view menu crm routes'],
  },
  children: [
    {
      path: 'wizard',
      component: () => import('@/views/crm/wizard/wizard.vue'),
      name: 'wizardCrm',
      meta: { title: 'wizardCrm', icon: 'magic' },
    },
    {
      path: 'leads',
      component: () => import('@/views/crm/leads/List'),
      name: 'LeadList',
      meta: { title: 'leadList', icon: 'lead', permissions: ['view lead', 'manage lead'] },
    },
    {
      path: 'pets',
      component: () => import('@/views/crm/pets/index'),
      name: 'PetList',
      meta: { title: 'petList', icon: 'bear' },
    },
    {
      path: 'pets/show/:id(\\d+)',
      component: () => import('@/views/crm/pets/Profile'),
      name: 'PetProfile',
      meta: { title: 'petProfile' },
      hidden: true,
    },
  ],
};

export default crmRoutes;
