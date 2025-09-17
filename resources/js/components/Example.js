import React, { useState, useEffect } from 'react';
import axios from 'axios';
import '../../sass/example.scss';

const Example = () => {
  const [people, setPeople] = useState([]);
  const [archivedPeople, setArchivedPeople] = useState([]);
  const [name, setName] = useState('');
  const [age, setAge] = useState('');
  const [bio, setBio] = useState('');
  const [formErrors, setFormErrors] = useState({});
  const [editingId, setEditingId] = useState(null);
  const [message, setMessage] = useState(null);
  const [showPeopleList, setShowPeopleList] = useState(true);
  const [showArchived, setShowArchived] = useState(false);
  const [showAddForm, setShowAddForm] = useState(false);

  const unwrap = (res) => {
    if (Array.isArray(res.data)) return res.data;
    if (res && res.data && res.data.data !== undefined) return res.data.data;
    return res.data;
  };

  const fetchPeople = () => {
    axios.get('/api/people')
      .then((res) => setPeople(unwrap(res) || []))
      .catch((err) => console.error('Failed fetch people:', err));
  };

  const fetchArchived = () => {
    axios.get('/api/people-archived')
      .then((res) => setArchivedPeople(unwrap(res) || []))
      .catch((err) => console.error('Failed fetch archived people:', err));
  };

  useEffect(() => {
    fetchPeople();
    fetchArchived();
  }, []);

  const resetForm = () => {
    setName('');
    setAge('');
    setBio('');
    setEditingId(null);
    setFormErrors({});
    setMessage(null);
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    const errors = {};
    if (!name.trim()) errors.name = 'Name is required';
    if (!age || isNaN(age)) errors.age = 'Valid age is required';
    if (!bio.trim()) errors.bio = 'Bio is required';

    if (Object.keys(errors).length > 0) {
      setFormErrors(errors);
      return;
    }

    const payload = { name, age: parseInt(age, 10), bio };

    if (editingId) {
      axios.put(`/api/people/${editingId}`, payload)
        .then(() => {
          fetchPeople();
          setMessage('✅ Updated successfully');
          resetForm();
          setShowAddForm(false);
        })
        .catch(() => setMessage('❌ Something went wrong while updating'));
    } else {
      axios.post('/api/people', payload)
        .then(() => {
          fetchPeople();
          setMessage('✅ Added successfully');
          resetForm();
          setShowAddForm(false);
        })
        .catch(() => setMessage('❌ Something went wrong while adding'));
    }
  };

  const handleEdit = (person) => {
    setEditingId(person.id);
    setName(person.name || '');
    setAge(person.age ? String(person.age) : '');
    setBio(person.bio || '');
    setMessage(null);
    setShowAddForm(true);
  };

  const handleArchive = (id) => {
    if (!window.confirm('Move this person to archive?')) return;

    axios.put(`/api/people/${id}/archive`)
      .then(() => {
        fetchPeople();
        fetchArchived();
        setMessage('📦 Archived successfully');
        if (editingId === id) resetForm();
        setShowAddForm(false);
      })
      .catch(() => setMessage('❌ Something went wrong while archiving'));
  };

  const handleDeleteArchived = (id) => {
    if (!window.confirm('Permanently delete this archived person?')) return;

    axios.delete(`/api/people/${id}/force`)
      .then(() => {
        fetchArchived();
        setMessage('🗑️ Deleted permanently');
      })
      .catch(() => setMessage('❌ Something went wrong while deleting'));
  };

  const handleRestoreFromArchive = (id) => {
    axios.put(`/api/people/${id}/restore`)
      .then(() => {
        fetchPeople();
        fetchArchived();
        setMessage('✅ Restored successfully');
        setShowPeopleList(true);
        setShowArchived(false);
      })
      .catch(() => setMessage('❌ Something went wrong while restoring'));
  };

  const handleTogglePeopleList = () => {
    setShowPeopleList((prev) => {
      if (!prev) {
        setShowArchived(false);
        setShowAddForm(false);
      } else {
        setShowAddForm(false);
      }
      return !prev;
    });
  };

  const handleToggleArchived = () => {
    setShowArchived((prev) => {
      if (!prev) setShowPeopleList(false);
      return !prev;
    });
  };

  const handleAddPersonClick = () => {
    resetForm();
    setShowAddForm(true);
  };

  return (
    <div className="app-wrapper">
      <div className="header">
        <button onClick={handleTogglePeopleList} className="btn">
          {showPeopleList ? '➖ Hide People List' : '👥 Show People List'}
        </button>
        <button onClick={handleToggleArchived} className="btn">
          {showArchived ? '➖ Hide Archived' : '📦 Show Archived'}
        </button>
      </div>

      {/* People List Section */}
      {showPeopleList && (
        <>
          <div className="list-section">
            <h2>👥 People List</h2>
            <button onClick={handleAddPersonClick} className="btn primary" style={{ marginBottom: '1rem' }}>
              ➕ Add Person
            </button>
            <div className="people-list">
              {people.length > 0 ? (
                people.map((person) => (
                  <div key={person.id} className="person-card">
                    <div className="person-info">
                      <h3>{person.name} <span>({person.age})</span></h3>
                      <p>{person.bio}</p>
                    </div>
                    <div className="actions">
                      <button onClick={() => handleEdit(person)} className="btn small edit">✏️</button>
                      <button onClick={() => handleArchive(person.id)} className="btn small delete">🗑️</button>
                    </div>
                  </div>
                ))
              ) : (
                <p className="empty">No people added yet</p>
              )}
            </div>
          </div>

          {/* Add/Edit Person Form */}
          {showAddForm && (
            <div className="form-section">
              <div className="form-card">
                <h1>{editingId ? '✏️ Edit Person' : '➕ Add Person'}</h1>
                {message && <div className="toast">{message}</div>}

                <form onSubmit={handleSubmit}>
                  <div className="field">
                    <label>Full Name</label>
                    <input
                      type="text"
                      value={name}
                      onChange={(e) => setName(e.target.value)}
                      placeholder="John Doe"
                    />
                    {formErrors.name && <span className="error">{formErrors.name}</span>}
                  </div>

                  <div className="field">
                    <label>Age</label>
                    <input
                      type="number"
                      value={age}
                      onChange={(e) => setAge(e.target.value)}
                      placeholder="25"
                    />
                    {formErrors.age && <span className="error">{formErrors.age}</span>}
                  </div>

                  <div className="field">
                    <label>Short Bio</label>
                    <textarea
                      value={bio}
                      onChange={(e) => setBio(e.target.value)}
                      placeholder="Tell us something about yourself..."
                    />
                    {formErrors.bio && <span className="error">{formErrors.bio}</span>}
                  </div>

                  <div className="btn-group">
                    <button type="submit" className="btn primary">
                      {editingId ? 'Update' : 'Add'}
                    </button>
                    <button
                      type="button"
                      className="btn cancel"
                      onClick={() => {
                        resetForm();
                        setShowAddForm(false);
                      }}
                    >
                      Cancel
                    </button>
                  </div>
                </form>
              </div>
            </div>
          )}
        </>
      )}

      {/* Archived Section */}
      {showArchived && (
        <div className="list-section">
          <h2>📦 Archived People</h2>
          <div className="people-list">
            {archivedPeople.length > 0 ? (
              archivedPeople.map((person) => (
                <div key={person.id} className="person-card archived">
                  <div className="person-info">
                    <h3>{person.name} <span>({person.age})</span></h3>
                    <p>{person.bio}</p>
                  </div>
                  <div className="actions">
                    <button onClick={() => handleRestoreFromArchive(person.id)} className="btn small restore">♻️ Restore</button>
                    <button onClick={() => handleDeleteArchived(person.id)} className="btn small delete">🗑️ Delete</button>
                  </div>
                </div>
              ))
            ) : (
              <p className="empty">No archived people yet</p>
            )}
          </div>
        </div>
      )}
    </div>
  );
};

export default Example;
