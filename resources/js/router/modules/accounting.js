import Layout from '@/layout';

const accountingRoutes = {
  path: '/accounting',
  component: Layout,
  name: 'Accounting',
  meta: {
    title: 'accounting',
    icon: 'excel',
    permissions: ['view menu bookkepping routes'],
  },
  children: [
    /** Banking Managements */
    {
      path: 'banking',
      component: () => import('@/views/accounting/banking/index'),
      name: 'Banking',
      meta: { title: 'banking', icon: 'bank', permissions: ['view menu bookkepping routes'] },
      children: [
        /** Accounts Managements */
        {
          path: '/accounting/banking/account',
          component: () => import('@/views/accounting/banking/account'),
          name: 'Account',
          meta: { title: 'account', icon: 'account', permissions: ['view banking', 'manage banking'] },
        },
        /** Transfers Managements */
        {
          path: 'transfer',
          component: () => import('@/views/accounting/banking/transfer'),
          name: 'Transfer',
          meta: { title: 'transfer', icon: 'transfer', permissions: ['view banking', 'manage banking'] },
        },
      ],
    },
    /** Expense Managements */
    {
      path: 'expense',
      component: () => import('@/views/accounting/expense/index'),
      name: 'Expense',
      meta: { title: 'expense', icon: 'expense', permissions: ['view menu bookkepping routes'] },
      children: [
        /** Bill Managements */
        {
          path: 'bill',
          component: () => import('@/views/accounting/expense/bill'),
          name: 'Bill',
          meta: { title: 'bill', icon: 'bill', permissions: ['view banking', 'manage banking'] },
        },
        /** Bill Managements */
        {
          path: 'vendor',
          component: () => import('@/views/accounting/expense/vendor'),
          name: 'Vendor',
          meta: { title: 'vendor', icon: 'vendor', permissions: ['view banking', 'manage banking'] },
        },
      ],
    },
    /** Income Managements */
    {
      path: 'income',
      component: () => import('@/views/accounting/income/index'),
      name: 'Income',
      meta: { title: 'income', icon: 'income', permissions: ['view menu bookkepping routes'] },
      children: [
        /** Contract Managements */
        {
          path: 'contract',
          component: () => import('@/views/accounting/income/contract'),
          name: 'Contract',
          meta: { title: 'contract', icon: 'contract' },
        },
        /** Revenue Managements */
        {
          path: 'revenue',
          component: () => import('@/views/accounting/income/revenue'),
          name: 'Revenue',
          meta: { title: 'revenue', icon: 'revenue' },
        },
      ],
    },
  ],
};

export default accountingRoutes;
