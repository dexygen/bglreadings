class ReadingDateInput extends React.Component {
  componentDidMount() {
    this.refs.dateInput.focus();
    this.refs.dateInput.value = (new Date()).toISOString().substr(0,10);
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