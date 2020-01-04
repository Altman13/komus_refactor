export const buildActionCreator = (type: any) => {
  return (payload = {}) => ({
    type,
    payload,
  });
};

export const buildRequestActionTypes = (type: any, namespace: any) => ({
  [`${type}_REQUEST`]: `${namespace}/${type}_REQUEST`,
  [`${type}_SUCCESS`]: `${namespace}/${type}_SUCCESS`,
  [`${type}_FAILURE`]: `${namespace}/${type}_FAILURE`,
});

export const buildEventActionCreator = (type: any) => {
  return (name = '', data = {}) => ({
    payload: {},
    event: {
      name,
      data,
    },
  });
};

const mapTypeToRequest = (type: any) => ({
  request: buildActionCreator(`${type}_REQUEST`),
  success: buildActionCreator(`${type}_SUCCESS`),
  failure: buildActionCreator(`${type}_FAILURE`),
});

export const buildRequestCreator = (type: any, requestCallback: any) => {
  const request = mapTypeToRequest(type);
  return (payload = {}) => (dispatch: any) => requestCallback({ request, payload, dispatch });
};
