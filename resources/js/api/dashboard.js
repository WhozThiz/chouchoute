import request from '@/utils/request';
import Resource from '@/api/resource';

class DashboardResource extends Resource {
  countarticles(query) {
    return request({
      url: '/countarticles',
      method: 'get',
      params: query,
    });
  }
  countleads(query) {
    return request({
      url: '/countleads',
      method: 'get',
      params: query,
    });
  }
  countpets(query) {
    return request({
      url: '/countpets',
      method: 'get',
      params: query,
    });
  }
  countcontracts(query) {
    return request({
      url: '/countcontracts',
      method: 'get',
      params: query,
    });
  }
}

export { DashboardResource as default };
