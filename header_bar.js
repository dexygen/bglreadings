class HeaderBar extends React.Component {
  constructor(props) {
    super(props);
    this.state = { isOpen: false };
  }
  
  toggleModal = () => {
    this.setState({
      isOpen: !this.state.isOpen
    });
  }
  
  saveReading = () => {
    console.log(this.state);
  }
  
  updateDate = (dateVal) => {
    this.setState({date: dateVal});
  }
  
  updateReading = () => {
    this.setState({reading: this.refs.readingInput.value});
  }
  
  render() {
    return (
      <div>
        <div id="header-bar">
          <a href="#" onClick={this.toggleModal}>Add Reading</a>
        </div>
        <AddReadingModal show={this.state.isOpen} onClose={this.toggleModal} saveReading={this.saveReading} >
          <h2>Add Reading</h2>
          <form>
              <ReadingDateInput changeHandler={this.updateDate} />
              <div className="form-element">
                  <label>Reading</label><input ref="readingInput" onChange={this.updateReading} />
              </div>
          </form>
          <div>&nbsp;</div>
        </AddReadingModal>
      </div>
    );
  }
}