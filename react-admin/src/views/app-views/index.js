import React, { lazy, Suspense } from "react";
import { Switch, Route, Redirect } from "react-router-dom";
import Loading from 'components/shared-components/Loading';
import { APP_PREFIX_PATH } from 'configs/AppConfig'

export const AppViews = () => {
  return (
    <Suspense fallback={<Loading cover="content"/>}>
      <Switch>
        <Route path={`${APP_PREFIX_PATH}/dashboard`} component={lazy(() => import(`./dashboard`))} />
        <Route path={`${APP_PREFIX_PATH}/cars`} component={lazy(() => import(`./cars`))} />
        <Route path={`${APP_PREFIX_PATH}/cars_data`} component={lazy(() => import(`./cars_data`))} />
        <Route path={`${APP_PREFIX_PATH}/list_car`} component={lazy(() => import(`./list_car`))} />
        <Route path={`${APP_PREFIX_PATH}/users`} component={lazy(() => import(`./users`))} />
        <Route path={`${APP_PREFIX_PATH}/trips`} component={lazy(() => import(`./trips`))} />
        <Route path={`${APP_PREFIX_PATH}/earnings`} component={lazy(() => import(`./earnings`))} />
        <Route path={`${APP_PREFIX_PATH}/role`} component={lazy(() => import(`./role`))} />
        <Route path={`${APP_PREFIX_PATH}/admin`} component={lazy(() => import(`./admin`))} />
        <Route path={`${APP_PREFIX_PATH}/logout`} component={lazy(() => import(`./logout`))} />
        <Redirect from={`${APP_PREFIX_PATH}`} to={`${APP_PREFIX_PATH}/dashboard`} />
      </Switch>
    </Suspense>
  )
}

export default React.memo(AppViews);