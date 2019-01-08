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
  
  render() {
    return (
      <div>
        <div id="header-bar">
          <a href="#" onClick={this.toggleModal}>Add Reading</a>
        </div>
        <AddReadingModal show={this.state.isOpen} onClose={this.toggleModal}>
          <h2>Add Reading</h2>
          <form>
              <div className="form-element">
                  <label>Date</label><input />
              </div>
              <div className="form-element">
                  <label>Reading</label><input />
              </div>
          </form>
          <div>&nbsp;</div>
        </AddReadingModal>
      </div>
    );
  }
}