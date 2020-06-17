import request from '@/utils/request';
import Resource from '@/api/resource';

class CategoryResource extends Resource {
  getPetCategories(query) {
    return request({
      url: '/petcategories',
      method: 'get',
      params: query,
    });
  }
  getVaccineCategories(query) {
    return request({
      url: '/vaccinecategories',
      method: 'get',
      params: query,
    });
  }
}

export { CategoryResource as default };
