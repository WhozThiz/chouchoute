import request from '@/utils/request';
import Resource from '@/api/resource';

class CategoryResource extends Resource {
  getCurrencyCategories(query) {
    return request({
      url: '/currencycategories',
      method: 'get',
      params: query,
    });
  }

  getMedicationCategories(query) {
    return request({
      url: '/medicationcategories',
      method: 'get',
      params: query,
    });
  }

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
