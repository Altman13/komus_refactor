import { Store, createStore } from "redux";
import { RootState, rootReducer } from "../reducers";

export function configureStore(initialState?: RootState): Store<RootState> {
  }
  const store = createStore(
    rootReducer as any,
    initialState as any,
  ) as Store<RootState>;

  if (module.hot) {
    module.hot.accept("app/reducers", () => {
      const nextReducer = require("app/reducers");
      store.replaceReducer(nextReducer);
    });
  }

  return store;
}
