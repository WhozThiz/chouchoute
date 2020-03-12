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
      path: 'leads',
      component: () => import('@/views/crm/leads/List'),
      name: 'LeadList',
      meta: { title: 'leadList', icon: 'lead', permissions: ['view lead', 'manage lead'] },
    },
    {
      path: 'humans',
      component: () => import('@/views/crm/humans/index'),
      name: 'Humans',
      meta: { title: 'humans', icon: 'humans' },
    },
    {
      path: 'pets',
      component: () => import('@/views/crm/pets/index'),
      name: 'Pets',
      meta: { title: 'pets', icon: 'bear' },
    },
  ],
};

export default crmRoutes;
