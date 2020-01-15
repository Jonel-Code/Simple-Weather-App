import moment from 'moment';

export default {
  formatUnixDate (unixDate) {
    return new Date(unixDate * 1000);
  },
  getWeekDayFromDate (date) {
    return moment(date).format('ddd');
  },
  getFormattedCurrentDate () {
    return moment().format('dddd MMMM DD, YYYY');
  },
};
