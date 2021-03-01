import Layout from '@/layout';

const productivityRoutes = {
  path: '/productivity',
  component: Layout,
  redirect: '/productivity',
  name: 'Productivity',
  meta: {
    title: 'productivity',
    icon: 'task-list',
    permissions: ['view menu productivity routes'],
  },
  children: [
    {
      path: 'calendar',
      component: () => import('@/views/productivity/calendar/index'),
      name: 'Calendar',
      meta: { title: 'calendar', icon: 'calendar' },
    },
    {
      path: 'task',
      component: () => import('@/views/productivity/task/index'),
      name: 'Task',
      meta: { title: 'tasks', icon: 'tasks' },
    },
    {
      path: 'todo',
      component: () => import('@/views/productivity/todo/index'),
      name: 'ToDo',
      meta: { title: 'todo', icon: 'todo' },
    },
  ],
};

export default productivityRoutes;
