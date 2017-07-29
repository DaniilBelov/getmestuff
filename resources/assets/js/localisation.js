import Vuex from 'vuex';
import vuexI18n from 'vuex-i18n';
import moment from 'moment';

const store = new Vuex.Store();

Vue.use(vuexI18n.plugin, store);

const translationsEn = {
    'no-relevant-results': 'There are no relevant results at this moment.',

    /* Wish */
    total: "Total",
    progress: 'Progress',
    collected: 'Collected',
    donate: 'Donate',
    report: 'Report',

    /* Achievements */
    redeem: 'Redeem points for prizes',
    'not-redeem': 'Go back',

    /* Profile Settings */
    edit: 'Edit Profile',
    'first_name': 'Your First Name',
    'last_name': 'Your Last Name',
    email: 'Your Email',
    'edit_password': 'Change Password',
    'current_password': 'Current Password',
    confirm: 'Please enter your password to confirm changes',
    save: 'Save Settings',

    /* Top Up */
    wallet: 'Wallet Top Up',
    amount: 'Amount',
    interest: 'Amount with Interest',
    'top-up': 'Top Up',

    /* Make a Wish */
    wish: 'Make a Wish',
    priority: 'This wish\'s priority will be higher.',
    item: 'What is Your Wish?',
    link: 'Link to your desired product...',
    current: 'Current Amount (default: 0)',
    needed: 'Amount Needed',
    address: 'Please provide your full address\:',
    address1: 'Address 1',
    address2: 'Address 2 (optional)',
    city: 'City',
    zip: 'Post Code',
    country: 'Country',
    request: 'Make Your Wish',
    'not-donated': 'Looks like you haven\'t donated yet. Please make a donation of any amount first.',

    /* Random Wish */
    random: 'Random Wish',

    /* User Wishes */
    user: 'Your Current Wish',
    'no-wishes': 'You don\'t have any wishes yet.',

    /* Notification */
    today: 'Today',
    yesterday: 'Yesterday',
    'no-notifications': 'No current notifications.',

     /* Transaction */
    transactions: 'Transactions',
    'no-transactions': 'You haven\'t made any transactions yet.',

    /* Paginator */
    next: 'Next',
    prev: 'Prev',

    /* Payments */
    'wallet-top-up': 'Wallet Top Up',
    disabled: 'Sorry, payment systems are currently disabled.',

    /* Flash */
    success: 'Success',
    error: 'Error',

    /* Contact */
    'contact-email': 'Email',
    subject: 'Subject',
    org: 'Organisation (optional)',
    message: 'Your message...',
    send: 'Send',

    /* Password Reset */
    'your-email': 'Enter your email:',
    'check-inbox': 'Check your inbox',

    /* Etc */
    reason: 'Reason'
};

const translationsRu = {
    'no-relevant-results': 'На данный момент нет соответствующих результатов',

    /* Wish */
    total: "Всего",
    progress: 'Прогресс',
    collected: 'Собрано',
    donate: 'ОК',
    report: 'Пожаловаться',

    /* Achievements */
    redeem: 'Обменять очки на призы',
    'not-redeem': 'Вернутся назад',

    /* Profile Settings */
    edit: 'Настроить профиль',
    'first_name': 'Ваше имя',
    'last_name': 'Ваша фамилия',
    email: 'Ваш email',
    'edit_password': 'Изменить пароль',
    'current_password': 'Текущий пароль',
    confirm: 'Введите пароль что бы подтвердить изменения',
    save: 'Сохранить',

    /* Top Up */
    wallet: 'Пополнить кошелек',
    amount: 'Сумма',
    interest: 'Сумма с комиссией',
    'top-up': 'Пополнить',

    /* Make a Wish */
    wish: 'Создать желание',
    priority: 'Приоритет этого желания будет выше.',
    item: 'Что бы вы хотели?',
    link: 'Ссылка на желаемый продукт...',
    current: 'Текущая Сумма (0)',
    needed: 'Необхадимая Сумма',
    address: 'Пожалуйста, укажите свой полный адрес\:',
    address1: 'Адрес 1',
    address2: 'Адрес 2 (необязательно)',
    city: 'Город',
    zip: 'Индекс',
    country: 'Страна',
    request: 'Загрузить',
    'not-donated': 'Похоже вы еще не пожертвовали. Пожалуйста, пожертвуйте любую сумму.',

    /* Random Wish */
    random: 'Случайное желание',

    /* User Wishes */
    user: 'Ваше текущее желание',
    'no-wishes': 'У вас пока нет желаний.',

    /* Notification */
    today: 'Сегодня',
    yesterday: 'Вчера',
    'no-notifications': 'У вас пока нет уведомлений.',

    /* Transaction */
    transactions: 'Операции',
    'no-transactions': 'Вы еще не осуществаляли никаких операций.',

    /* Paginator */
    next: 'След.',
    prev: 'Пред.',

    /* Payments */
    'wallet-top-up': 'Пополнение кошелька',
    disabled: 'Извините, в настоящее время платежные системы отключены.',

    /* Flash */
    success: 'Удачно',
    error: 'Ошибка',

    /* Contact */
    'contact-email': 'Email',
    subject: 'Тема',
    org: 'Организация (не обязательно)',
    message: 'Ваше сообщение...',
    send: 'Отправить',

    /* Password Reset */
    'your-email': 'Ваш email:',
    'check-inbox': 'Проверте почту',

    /* Etc */
    reason: 'Причина'
};

Vue.i18n.add('en', translationsEn);
Vue.i18n.add('ru', translationsRu);

let locale = document.head.querySelector('meta[name="locale"]');

moment.locale(locale.content);

window.flashMessages = {
    en: {
        'for-donating': 'Thank you for donating.',
        'for-reporting': 'The wish has been reported.',
        'for-reporting-fail': 'Something went wrong!',
        'published-wish': 'Your wish has been published.',
        redeemed: 'All done.',
        'profile-updated': 'Profile updated.',
        'verify-email': 'Please verify your new email.',
        'contact-message': 'Thank you for your message, we will reply soon.',
        'deleting': 'Wish has been deleted',
        construction: {
            0: 'Fixing Bugs',
            1: 'Updating',
            2: 'Back Soon'
        }
    },
    ru: {
        'for-donating': 'Благодарим за пожертвование.',
        'for-reporting': 'Вы успешно сообщили о нарушении.',
        'for-reporting-fail': 'Что-то пошло не так!',
        'published-wish': 'Ваше желание опубликовано.',
        redeemed: 'Все успешно.',
        'profile-updated': 'Информация обнавленна.',
        'verify-email': 'Пожалуйста, подтвердите ваш новый email.',
        'contact-message': 'Спасибо за ваше сообщение, мы скоро ответим.',
        'deleting': 'Желание было удаленно',
        construction: {
            0: 'Исправление ошибок',
            1: 'Обновление',
            2: 'Скоро вернемся'
        }
    }
};