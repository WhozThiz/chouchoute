import Vue from 'vue';
import VueI18n from 'vue-i18n';
import Cookies from 'js-cookie';
import elementEnLocale from 'element-ui/lib/locale/lang/en'; // element-ui lang
import elementPtLocale from 'element-ui/lib/locale/lang/pt-br'; // element-ui lang
import enLocale from './en';
import ptLocale from './pt_BR';

Vue.use(VueI18n);

const messages = {
  en: {
    ...enLocale,
    ...elementEnLocale,
  },
  pt_BR: {
    ...ptLocale,
    ...elementPtLocale,
  },
};

export function getLanguage() {
  const chooseLanguage = Cookies.get('language');
  if (chooseLanguage) {
    return chooseLanguage;
  }

  // if has not choose language
  const language = (navigator.language || navigator.browserLanguage).toLowerCase();
  const locales = Object.keys(messages);
  for (const locale of locales) {
    if (language.indexOf(locale) > -1) {
      return locale;
    }
  }
  return 'en';
}
const i18n = new VueI18n({
  // set locale
  // options: en | pt
  locale: getLanguage(),
  // set locale messages
  messages,
});

export default i18n;
