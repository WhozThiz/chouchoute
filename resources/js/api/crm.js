import request from '@/utils/request';
import Resource from '@/api/resource';

class CrmResource extends Resource {
  medications(query) {
    return request({
      url: '/medications',
      method: 'get',
      params: query,
    });
  }

  vaccines(query) {
    return request({
      url: '/vaccines',
      method: 'get',
      params: query,
    });
  }

  multistore(query) {
    return request({
      url: '/vaccines',
      method: 'get',
      params: query,
    });
  }
}

export { CrmResource as default };
