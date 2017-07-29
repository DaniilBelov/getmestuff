Parsley.addMessages('en', {
    defaultMessage: "This value seems to be invalid.",
    type: {
        email:        "Please provide a valid email",
        url:          "Please provide a valid url",
        number:       "This value should be a valid number.",
        integer:      "This value should be a valid integer.",
        digits:       "This value should be digits.",
        alphanum:     "This value should be alphanumeric."
    },
    notblank:       "This value should not be blank.",
    required:       "This field is required.",
    pattern:        "This value seems to be invalid.",
    min:            "This value should be greater than or equal to %s.",
    max:            "This value should be lower than or equal to %s.",
    range:          "This value should be between %s and %s.",
    minlength:      "This value is too short. It should have %s characters or more.",
    maxlength:      "This value is too long. It should have %s characters or fewer.",
    length:         "This value length is invalid. It should be between %s and %s characters long.",
    mincheck:       "You must select at least %s choices.",
    maxcheck:       "You must select %s choices or fewer.",
    check:          "You must select between %s and %s choices.",
    equalto:        "The fields don't match"
});

Parsley.addMessages('ru', {
  defaultMessage: "Некорректное значение.",
  type: {
    email:        "Введите адрес электронной почты.",
    url:          "Введите URL адрес.",
    number:       "Введите число.",
    integer:      "Введите целое число.",
    digits:       "Введите только цифры.",
    alphanum:     "Введите буквенно-цифровое значение."
  },
  notblank:       "Это поле должно быть заполнено.",
  required:       "Обязательное поле.",
  pattern:        "Это значение некорректно.",
  min:            "Это значение должно быть не менее чем %s.",
  max:            "Это значение должно быть не более чем %s.",
  range:          "Это значение должно быть от %s до %s.",
  minlength:      "Это значение должно содержать не менее %s символов.",
  maxlength:      "Это значение должно содержать не более %s символов.",
  length:         "Это значение должно содержать от %s до %s символов.",
  mincheck:       "Выберите не менее %s значений.",
  maxcheck:       "Выберите не более %s значений.",
  check:          "Выберите от %s до %s значений.",
  equalto:        "Это значение должно совпадать."
});

Parsley.setLocale(window.App.locale);