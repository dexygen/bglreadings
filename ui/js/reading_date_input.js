class ReadingDateInput extends React.Component {
  componentDidMount() {
    this.refs.dateInput.focus();
    this.refs.dateInput.value = (function() { //see: https://stackoverflow.com/a/54341296/34806
      let now = new Date();
      let month = (now.getMonth() + 1).toString().padStart(2, '0');
      let day = now.getDate().toString().padStart(2, '0');
      return `${now.getFullYear()}-${month}-${day}`;
    })();
  }
  
  updateDate = () => {
    this.props.changeHandler(this.refs.dateInput.value);
  }
  
  render() {
    return (
      <div className="form-element">
          <label>Date</label><input type="date" ref="dateInput" onChange={this.updateDate} />
      </div>
    );
  }
}