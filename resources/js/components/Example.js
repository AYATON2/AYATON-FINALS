import React, { useState, useEffect } from 'react';
import axios from 'axios';
import '../../sass/example.scss';

const Example = () => {
  const [people, setPeople] = useState([]);
  const [name, setName] = useState('');
  const [age, setAge] = useState('');
  const [bio, setBio] = useState('');
  const [formErrors, setFormErrors] = useState({});
  const [editingId, setEditingId] = useState(null);
  const [message, setMessage] = useState(null);

  useEffect(() => {
    axios.get('/api/people')
      .then((res) => setPeople(res.data))
      .catch((err) => console.error(err));
  }, []);

  const resetForm = () => {
    setName('');
    setAge('');
    setBio('');
    setEditingId(null);
    setFormErrors({});
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    const errors = {};
    if (!name) errors.name = 'Name is required';
    if (!age) errors.age = 'Age is required';
    if (!bio) errors.bio = 'Bio is required';

    if (Object.keys(errors).length === 0) {
      if (editingId) {
        axios.put(`/api/people/${editingId}`, { name, age, bio })
          .then((res) => {
            setPeople((prev) =>
              prev.map((p) => (p.id === editingId ? res.data : p))
            );
            setMessage('✅ Updated successfully');
            resetForm();
          });
      } else {
        axios.post('/api/people', { name, age, bio })
          .then((res) => {
            setPeople((prev) => [...prev, res.data]);
            setMessage('✅ Added successfully');
            resetForm();
          });
      }
    } else {
      setFormErrors(errors);
    }
  };

  const handleEdit = (person) => {
    setEditingId(person.id);
    setName(person.name);
    setAge(person.age);
    setBio(person.bio);
    setMessage(null);
  };

  const handleDelete = (id) => {
    if (window.confirm('Delete this person?')) {
      axios.delete(`/api/people/${id}`)
        .then(() => {
          setPeople((prev) => prev.filter((p) => p.id !== id));
          setMessage('🗑️ Deleted successfully');
          if (editingId === id) resetForm();
        });
    }
  };

  return (
    <div className="people-container">
      <header>
        <h1>👥 People Manager</h1>
        {message && <div className="toast">{message}</div>}
      </header>

      <div className="grid-layout">
        {/* People List */}
        <div className="people-list">
          {people.length > 0 ? (
            people.map((person) => (
              <div key={person.id} className="person-card">
                <div className="info">
                  <h3>{person.name} <span>({person.age})</span></h3>
                  <p>{person.bio}</p>
                </div>
                <div className="actions">
                  <button onClick={() => handleEdit(person)} className="btn edit">✏️</button>
                  <button onClick={() => handleDelete(person.id)} className="btn delete">🗑️</button>
                </div>
              </div>
            ))
          ) : (
            <p className="empty">No people added yet</p>
          )}
        </div>

        {/* Add/Edit Form */}
        <div className="form-container">
          <h2>{editingId ? '✏️ Edit' : '➕ Add'}</h2>
          <form onSubmit={handleSubmit}>
            <input
              type="text"
              value={name}
              onChange={(e) => setName(e.target.value)}
              placeholder="Full name"
            />
            {formErrors.name && <span className="error">{formErrors.name}</span>}

            <input
              type="number"
              value={age}
              onChange={(e) => setAge(e.target.value)}
              placeholder="Age"
            />
            {formErrors.age && <span className="error">{formErrors.age}</span>}

            <textarea
              value={bio}
              onChange={(e) => setBio(e.target.value)}
              placeholder="Short bio"
            />
            {formErrors.bio && <span className="error">{formErrors.bio}</span>}

            <div className="btn-group">
              <button type="submit" className="btn primary">
                {editingId ? 'Update' : 'Add'}
              </button>
              {editingId && (
                <button type="button" className="btn cancel" onClick={resetForm}>
                  Cancel
                </button>
              )}
            </div>
          </form>
        </div>
      </div>
    </div>
  );
};

export default Example;
