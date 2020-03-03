/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const crmRoutes = {
  path: '/crm',
  component: Layout,
  redirect: '/crm',
  name: 'CRM',
  meta: {
    title: 'crm',
    icon: 'crm',
    permissions: ['view menu crm routes'],
  },
  children: [
    {
      path: 'leads',
      component: () => import('@/views/crm/leads/List'),
      name: 'Leads',
      meta: { title: 'leads' },
    },
    {
      path: 'leads/edit/:id(\\d+)',
      component: () => import('@/views/crm/leads/Edit'),
      name: 'Editlead',
      meta: { title: 'editLead', noCache: true, permissions: ['manage lead'] },
      hidden: true,
    },
    {
      path: 'humans',
      component: () => import('@/views/crm/humans/index'),
      name: 'Humans',
      meta: { title: 'humans' },
    },
    {
      path: 'pets',
      component: () => import('@/views/crm/pets/index'),
      name: 'Pets',
      meta: { title: 'pets' },
    },
  ],
};

export default crmRoutes;
