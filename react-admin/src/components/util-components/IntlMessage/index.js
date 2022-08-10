import React from "react";
import {FormattedMessage, injectIntl} from "react-intl";

const IntlMessage = props => <FormattedMessage {...props} />;
export default injectIntl(IntlMessage, {
  withRef: false
});
