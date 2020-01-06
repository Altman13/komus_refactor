import ApiService from './Api';

const JSON_QUERY = '.json?print=pretty';
const BASE_URL = '/react/php/komus_new/test.php';
const client = new ApiService({ baseURL: BASE_URL });

const CallsApi = {};

CallsApi.getCalls = () => client.get(`/calls${JSON_QUERY}`);
CallsApi.getCall = id => client.get(`/calls/${id}${JSON_QUERY}`);
CallsApi.postCall = id => client.post(`/calls/${JSON_QUERY}`);

export default CallsApi;
