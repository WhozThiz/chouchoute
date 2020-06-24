import Layout from '@/layout';

const accountingRoutes = {
  path: '/accounting',
  component: Layout,
  name: 'Accounting',
  meta: {
    title: 'accounting',
    icon: 'excel',
  },
  children: [
    /** Banking Managements */
    {
      path: 'banking',
      // component: () => import('@/views/accounting/banking'),
      name: 'Banking',
      meta: { title: 'banking', icon: 'bank' },
    },
    /** Expense Managements */
    {
      path: 'expense',
      // component: () => import('@/views/accounting/expense'),
      name: 'Expense',
      meta: { title: 'expense', icon: 'expense' },
    },
    /** Income Managements */
    {
      path: 'income',
      // component: () => import('@/views/accounting/income'),
      name: 'Income',
      meta: { title: 'income', icon: 'income' },
    },
  ],
};

export default accountingRoutes;
