class SaveReadingModal extends React.Component {
  render() {
    // Render nothing if the "show" prop is false
    if(!this.props.show) {
      return null;
    }

    // The gray background
    const backdropStyle = {
      position: 'fixed',
      top: 0,
      bottom: 0,
      left: 0,
      right: 0,
      backgroundColor: 'rgba(0,0,0,0.3)',
      padding: 50
    };

    // The modal "window"
    const modalStyle = {
      backgroundColor: '#fff',
      borderRadius: 5,
      maxWidth: 300,
      minHeight: 200,
      margin: '0 auto',
      padding: 30
    };

    return (
      <div className="backdrop" style={backdropStyle}>
        <div className="modal" style={modalStyle}>
          <h2>{this.props.saveMode} Reading</h2>
          <form>
              <ReadingDateInput ref="readingDate" changeHandler={this.props.updateDate} />
              <div className="form-element">
                  <label>Reading</label><input ref="readingInput" onChange={this.props.updateReading} />
              </div>
          </form>
          <div>&nbsp;</div>
          <div className="footer">
            <button onClick={this.props.saveReading}>
              Save
            </button>
            &nbsp;&nbsp;
            <button onClick={this.props.onClose}>
              Cancel
            </button>
          </div>
        </div>
      </div>
    );
  }
}